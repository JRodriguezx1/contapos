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