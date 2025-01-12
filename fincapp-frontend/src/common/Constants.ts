export const CONSTANTS = {
    BASE_API_URL : 'http://127.0.0.1:8000/api/',

    BASE_API_GROUP : {
        MATERIAL : 'materiales/',
        TERCEROS : 'terceros/',
        COMPRA : 'compras/',
        FACTURA : 'facturas/',
        KARDEX : 'kardexes/',
        CULTIVOS : 'cultivos/',
    },

    TIPO_MOVIMIENTO_KARDEX : {
        ENTRA : "Entra",
        SALE : "Sale",
    },

    NOTIFICACIONES_MENSAJES : {
        SUCCESS : "Operacion realizada con éxito",
        FAIL : "No fué posible realizar la operacion",
        WARNING : "Tenga cuidado con esta operación",
    },

    MATERIALES : {
        UNIDADES : ["Unidad", "Lote", "Totalidad", "Docena", "Decena", "Kilos"],
        TIPOS_MATERIAL : ["Insumo", "Animal", "Producido", "Cultivo"]
    }
}