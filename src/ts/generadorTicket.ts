type Align = 'left' | 'center' | 'right';
class EscPosBuilder {

    protected content = '';
    protected bytes: number[] = [];

    protected write(...bytes: number[]) {
        this.bytes.push(...bytes);
    }

   // Comando Reset: Limpia formatos previos
    reset() {
        this.content += '\x1B\x40';
        this.setAlign('left');
        // Bold OFF
        this.boldOff();
        // Tamaño normal
        this.normalSize();
    }

    text(text: string = '') {
        this.content += text + '\n';
    }

    // Agregamos Tamaño de texto (Doble ancho y alto)
    bigText(text: string, bold = false) {
        if(bold)this.boldOn();
        this.doubleSize();
        this.text(text);
        this.normalSize();
        if(bold)this.boldOff();
    }

    line() {
        this.text('-'.repeat(42));
    }

    // 1. Forzar que el centro sea una operación aislada y limpia
    center(text: string) {
        this.setAlign('center');         // Activar centro
        this.text(text);                 // Escribir texto y saltar (imprime el buffer)
        this.setAlign('left');           // Volver a izquierda INMEDIATAMENTE
    }

    setAlign(mode: 'left' | 'center' | 'right') {
        const map = {
            left: 0,
            center: 1,
            right: 2
        };
        // ESC a n
        this.content += `\x1B\x61${String.fromCharCode(map[mode])}`;
    }

    boldOn(){
        this.content += '\x1B\x45\x01';
    }

    boldOff(){
        this.content += '\x1B\x45\x00';
    }

    bold(text: string) {
        this.boldOn();
        this.text(text);
        this.boldOff();
    }

    normalSize(){
        this.content += '\x1D\x21\x00';
    }

    doubleHeight() {
        this.content += '\x1D\x21\x01';
    }

    doubleWidth() {
        this.content += '\x1D\x21\x10';
    }

    doubleSize() {
        // GS ! 17
        // doble ancho + doble alto
        this.content += '\x1D\x21\x11';
    }

    feed(lines: number = 3) {
        this.content += '\n'.repeat(lines);
    }

    cut() {
        this.feed(5);
        this.content += '\x1D\x56\x00';
    }

    row(left: string, right: string, width = 42) {
        const spaces = width - left.length - right.length;
        this.text(left+' '.repeat(Math.max(1, spaces))+right);
    }

    wrap(text: string, width = 42): string[] {
        const words = text.split(' ');
        const lines: string[] = [];
        let current = '';
        for(const word of words) {
            if((current + word).length > width) {
                lines.push(current.trim());
                current = '';
            }
            current += word + ' ';
        }
        if(current.trim())lines.push(current.trim());
        return lines;
    }

    column(text: string, width: number, align: 'left' | 'center' | 'right' = 'left'){
        // evitar overflow
        if(text.length > width) {
            text = text.substring(0, width);
        }
        switch(align){
            case 'left':
                return text.padEnd(width, ' ');
            case 'right':
                return text.padStart(width, ' ');
            case 'center':
                const totalSpaces = width - text.length;
                const left = Math.floor(totalSpaces / 2);
                const right = totalSpaces - left;
                return (' '.repeat(left)+text +' '.repeat(right));
        }
    }

    row3(col1: string, col2: string, col3: string, align: Record<string, Align> = {col1: 'left', col2: 'right', col3: 'right'}, whidth:number[] = [8, 16, 18]){
        const line = this.column(col1, whidth[0], align.col1) + this.column(col2, whidth[1], align.col2) + this.column(col3, whidth[2], align.col3);
        this.text(line);
    }


    qr(data: string, size = 6, errorLevel: 'L' | 'M' | 'Q' | 'H' = 'M') {
        const errorMap = { L: 48, M: 49, Q: 50, H: 51 };
        const store_len = data.length + 3;
        const pL = store_len % 256;
        const pH = Math.floor(store_len / 256);
        /*
        =========================================
        TAMAÑO QR
        =========================================
        */
        // GS ( k 3 0 49 67 n
        // tamaño módulo
        this.content +='\x1D\x28\x6B\x03\x00\x31\x43'+String.fromCharCode(size);
        /*
        =========================================
        NIVEL ERROR
        =========================================
        */
        // GS ( k 3 0 49 69 n
        this.content +='\x1D\x28\x6B\x03\x00\x31\x45'+String.fromCharCode(errorMap[errorLevel]);
        /*
        =========================================
        ALMACENAR DATA
        =========================================
        */
        this.content += '\x1D\x28\x6B' + String.fromCharCode(pL) + String.fromCharCode(pH) + '\x31\x50\x30' + data;
        /*
        =========================================
        IMPRIMIR QR
        =========================================
        */
        this.content += '\x1D\x28\x6B\x03\x00\x31\x51\x30';
        this.feed(1);
    }

    build() {
        return this.content;
    }
}


class InvoiceTicketBuilder extends EscPosBuilder {

    private invoice: DataInvoice;
    constructor(invoice: DataInvoice) {
        super();
        this.reset();
        this.invoice = invoice;
    }

    generate() {
        this.header();
        this.customer();
        this.datosFactura();
        this.cliente();
        this.items();
        this.totals();
        this.payments();
        this.footer();
        this.cut();
        return this.build();
    }

    private header() {
        this.boldOn();
        this.center(this.invoice.negocio.toUpperCase());
        this.boldOff();
        this.center(`NIT: ${this.invoice.nit.trim()}`);
        this.center(this.invoice.direccion.trim());
        this.center(`TEL: ${this.invoice.telefono.trim()}`);
        this.feed(1);
        this.line();
    }

    private customer() {
        if(this.invoice.consumidorfinal) {
            this.text('CONSUMIDOR FINAL');
            return;
        }
    }

    private datosFactura(){
        this.bold(`Factura: ${this.invoice.prefijo.trim()}${this.invoice.consecutivo.trim()}`);
        this.text(`Fecha pago: ${this.invoice.fechaPago.trim()}`);
        this.text(`CAJA: ${this.invoice.caja.trim()}`);
        this.text(`VENDEDOR: ${this.invoice.vendedor.trim()}`);
        this.line();
    }

    private cliente(){
        this.center(`Cliente: ${this.invoice.cliente.nombre.trim()}`);
        this.center(`Documento: ${this.invoice.cliente.identificacion.trim()}`);
        this.center(`Telefono: ${this.invoice.cliente.telefono.trim()}`);
        this.feed(1);
    }

    private items() {
        this.line();
        this.feed(1);
        this.boldOn();
        this.row3('CANT', 'UND', 'TOTAL', {col1:'left', col2:'right', col3:'right'}, [8, 16, 18]);
        this.boldOff();
        for(const item of this.invoice.items) {
            for(const line of this.wrap(item.nombreproducto.trim()))this.center(line);
            //this.row(`${item.cantidad}  x  $${item.valorunidad.toLocaleString()}`, '$'+item.total.toLocaleString());
            this.row3(item.cantidad.toString(), item.valorunidad.toLocaleString(), item.total.toLocaleString(), {col1:'left', col2:'right', col3:'right'}, [8, 16, 18]);
        }
    }

    private totals() {
        this.line();
        this.feed(1);
        this.setAlign('right');
        this.text(`SUBTOTAL: $${Number(this.invoice.subtotal.trim()).toLocaleString()}`);
        this.text(`IMPUESTO: $${Number(this.invoice.valorimpuestototal.trim()).toLocaleString()}`);
        this.bigText(`TOTAL: $${Number(this.invoice.total.trim()).toLocaleString()}`, true);
    }

    private payments() {
        this.feed(2);
        this.doubleHeight();
        for(const pago of this.invoice.mediospago) {
            //this.text(`${pago.mediopago}: $${pago.valor?.toLocaleString()}`);
            this.row3(' ', pago.mediopago+':', ` $${pago.valor?.toLocaleString()}`, {col1:'right', col2:'right', col3:'left'}, [10, 17, 15]);
        }
    }

    private footer() {
        this.normalSize();
        this.feed(1);
        this.line();
        this.feed(2)
        this.setAlign('center');
        this.qr('www.j2softwarepos.com/', 8, 'M');
        this.feed(2)
        this.boldOn();
        this.center('GRACIAS POR SU COMPRA');
        this.boldOff();
        this.center('www.j2softwarepos.com/');
        this.feed(1);
    }
}