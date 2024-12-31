<?php

namespace App\Common;

class Constants {


    public const MATERIALES_UNIDADES = ["Unidad", "Lote", "Totalidad", "Docena", "Decena", "Kilos"];
    public const MATERIALES_UNIDADES_UNIDAD = "Unidad";
    public const MATERIALES_UNIDADES_LOTE = "Lote";
    public const MATERIALES_UNIDADES_TOTALIDAD = "Totalidad";
    public const MATERIALES_UNIDADES_DECENA = "Decena";
    public const MATERIALES_UNIDADES_DOCENA = "Docena";
    public const MATERIALES_UNIDADES_KILOS = "Kilos";

    public const MATERIALES_TIPO_MATERIAL = ["Insumo", "Animal", "Producido", "Cultivo"];
    public const MATERIALES_TIPO_MATERIAL_INSUMO = "Insumo";
    public const MATERIALES_TIPO_MATERIAL_ANIMAL = "Animal";
    public const MATERIALES_TIPO_MATERIAL_PRODUCIDO = "Producido";
    public const MATERIALES_TIPO_MATERIAL_CULTIVO = "Cultivo";

    public const KARDEXES_TIPO_MOVIMIENTO = ["Entra", "Sale"];

    public const BIOMETRICOS_MATERIAL_SEXO = ["Macho", "Hembra", "Indeterminado"];
    public const BIOMETRICOS_MATERIAL_SEXO_MACHO = "Macho";
    public const BIOMETRICOS_MATERIAL_SEXO_HEMBRA = "Hembra";
    public const BIOMETRICOS_MATERIAL_SEXO_INDETERMINADO = "Indeterminado";

    public const BIOMETRICOS_MATERIAL_ADQUISICION = ["Compra", "Cría"];

    public const BIOMETRICOS_MATERIAL_TOMAS_ESTADOS = ["Vivo", "Muerto", "Cría", "Padrón", "Lactante/Con cría", "Preñada"];

    public const FACTURAS_ESTADOS = ["Debe", "Pagada"];
    public const FACTURA_ESTADOS_DEBE = "Debe";
    public const FACTURA_ESTADOS_PAGADA = "Pagada";

    public const KARDEX_TIPO_MOVIMIENTO_SALE = "Sale";
    public const KARDEX_TIPO_MOVIMIENTO_ENTRA = "Entra";
}
