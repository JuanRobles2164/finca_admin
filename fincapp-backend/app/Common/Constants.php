<?php

namespace App\Common;

class Constants {


    public const MATERIALES_UNIDADES = ["Unidad", "Lote", "Totalidad", "Docena", "Decena", "Bulto", "Kilos"];
    public const MATERIALES_TIPO_MATERIAL = ["Insumo", "Animal", "Producido", "Cultivo"];

    public const KARDEXES_TIPO_MOVIMIENTO = ["Entra", "Sale"];

    public const BIOMETRICOS_MATERIAL_SEXO = ["Macho", "Hembra", "Indeterminado"];
    public const BIOMETRICOS_MATERIAL_ADQUISICION = ["Compra", "Cría"];

    public const BIOMETRICOS_MATERIAL_TOMAS_ESTADOS = ["Vivo", "Muerto", "Cría", "Padrón", "Lactante/Con cría", "Preñada"];

    public const FACTURAS_ESTADOS = ["Debe", "Pagada"];
    public const FACTURA_ESTADOS_DEBE = "Debe";
    public const FACTURA_ESTADOS_PAGADA = "Pagada";

    public const KARDEX_TIPO_MOVIMIENTO_SALE = "Sale";
    public const KARDEX_TIPO_MOVIMIENTO_ENTRA = "Entra";
}
