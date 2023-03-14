import { ChessPiece } from "./ChessPiece";

export interface ChessTile {
    x: number;
    y: number;
    piece?: ChessPiece;
}