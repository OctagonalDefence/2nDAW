import { Component, OnInit } from '@angular/core';
import { ChessTile } from 'src/app/models/ChessTile';
import { MoveFinderService } from '../services/move-finder.service';

@Component({
  selector: 'app-chessboard',
  templateUrl: './chessboard.component.html',
  styleUrls: ['./chessboard.component.css']
})
export class ChessboardComponent implements OnInit {

  chessBoard!: ChessTile[][];
  selectedTile?: ChessTile;
  legalMoves!: ChessTile[];

  onSelect(tile: ChessTile): void {
    if (this.legalMoves.indexOf(tile)>-1 && this.selectedTile) {
      tile.piece = this.selectedTile.piece;
      this.selectedTile.piece = undefined;
      this.selectedTile = undefined;
      this.resetLegalMoves();
    }
    else if (tile === this.selectedTile) {
      this.selectedTile = undefined;
      this.resetLegalMoves();
    }
    else {
      this.selectedTile = tile;
      this.resetLegalMoves;
      this.legalMoves = this.moveFinder.findMoves(tile, this);
    }
  }

  getHorizontalShift(tile: ChessTile): string {
    return `${tile.x*50}px`;
  }

  getVerticalShift(tile: ChessTile): string {
    return `${tile.y*50}px`;
  }

  getChessPiece(tile: ChessTile): string {
    if (tile.piece) {
      return `${tile.piece.color}\n${tile.piece.type}`;
    }
    else {return "";}
  }

  buildBoard(): void {
    this.chessBoard = [];
    let x=0;
    for (x; x<8; x++) {
      let tileRow: ChessTile[] = [];
      let y=0;
      for (y; y<8; y++) {
        tileRow.push({x:x, y:y});
      }
      this.chessBoard.push(tileRow);
    }
  }

  resetLegalMoves(): void {
    this.legalMoves = [];
  }

  getTile(x:number, y:number): ChessTile {
    return this.chessBoard[x][y];
  }

  constructor(private moveFinder: MoveFinderService) { }

  ngOnInit(): void {
    this.buildBoard();
    this.resetLegalMoves();
    this.getTile(4,0).piece = {color: "Black", type: "King"};
    this.getTile(1,7).piece = {color: "White", type: "Knight"};
    this.getTile(2,0).piece = {color: "Black", type: "Bishop"};
    this.getTile(7,7).piece = {color: "White", type: "Rook"};
  }

}
