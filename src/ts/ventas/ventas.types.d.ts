type productsapi = {
      id:string,
      idcategoria: string,
      idunidadmedida: string,
      nombre: string,
      foto: string,
      impuesto: string,  //porcentaje(%) de impuesto
      marca: string,
      tipoproducto: string, // 0 = simple,  1 = compuesto
      tipoproduccion: string, //0 = inmediato, 1 = construccion (aplica para productos compuestos)
      codigo: string,
      unidadmedida: string,
      descripcion: string,
      peso: string,
      medidas: string,
      color: string,
      funcion: string,
      uso:string,
      fabricante: string,
      garantia: string,
      stock: string,
      stockminimo: string,
      categoria: string,
      rendimientoestandar: string,
      precio_compra: string,
      precio_venta: string,
      fecha_ingreso: string,
      estado: string,
      visible: string,
      preciosadicionales:{id:string, idproducto:string, precio:string, estado:string, created_at:string}[]
    };


interface MedioPago {
    id: string;
    mediopago: string;
    estado: string;
    nick?: string;
}
interface Cliente {
    id: string;
    nombre: string;
    apellido: string;
    tipodocumento: string;
    identificacion: string;
    telefono: string;
    email: string;
    fecha_nacimiento: string | null;
    total_compras: string | null;
    ultima_compra: string | null;
    totaldebe: string | null;
    limitecredito: string | null;
    data1: string | null;
    created_at: string;
}
interface CarritoItem {
    id: string;
    idproducto: string;
    tipoproducto: string;
    tipoproduccion: string;
    idcategoria: string;
    foto: string;
    nombreproducto: string;
    rendimientoestandar: string;
    costo: string;
    valorunidad: string;
    cantidad: number;
    subtotal: number;
    base: number;
    impuesto: string;
    valorimp: number;
    descuento: number;
    total: number;
}
interface DataInvoice {
    negocio: string;
    nit: string;
    direccion: string;
    telefono: string;
    email: string;
    num_orden: number;
    textFactura: string;
    prefijo: string;
    consecutivo: string;
    fechaPago: string;
    caja: string;
    vendedor: string;
    cliente: Cliente;
    items: CarritoItem[];
    mediospago: MedioPago[];
    tipoventa: string;
    subtotal: string;
    base: string;
    valorimpuestototal: string;
    descuento: string;
    total: string;
    observacion: string;
}
