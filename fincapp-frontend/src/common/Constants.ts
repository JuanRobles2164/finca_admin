export enum CONSTANTS {
    BASE_API_URL = 'http://127.0.0.1:8000/api/',

    BASE_API_GROUP_MATERIAL = 'materiales/',
    BASE_API_GROUP_TERCEROS = 'terceros/',
    BASE_API_GROUP_COMPRA = 'compras/',
    BASE_API_GROUP_FACTURA = 'facturas/',
    BASE_API_GROUP_KARDEX = 'kardexes/',
    BASE_API_GROUP_CULTIVOS = 'cultivos/',

    TIPO_MOVIMIENTO_KARDEX_ENTRA = "Entra",
    TIPO_MOVIMIENTO_KARDEX_SALE = "Sale",

    NOTIFICACIONES_MENSAJES_SUCCESS = "Operacion realizada con éxito",
    NOTIFICACIONES_MENSAJES_FAIL = "No fué posible realizar la operacion",
    NOTIFICACIONES_MENSAJES_WARNING = "Tenga cuidado con esta operación",
}