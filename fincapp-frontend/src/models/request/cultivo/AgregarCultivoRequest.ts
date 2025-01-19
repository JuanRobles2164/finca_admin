export interface AgregarCultivoRequest {
    material_id: number,
    edad: number,
    cantidad: number,
    adquisicion: "Compra" | "Cría"
}