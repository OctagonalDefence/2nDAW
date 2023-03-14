import { Injectable } from '@angular/core';
import { ChessTile } from 'src/app/models/ChessTile';
import { ChessboardComponent } from 'src/app/chessboard/chessboard.component';

@Injectable({
  providedIn: 'root'
})
export class MoveFinderService {
  
  findMoves(tile: ChessTile, board: ChessboardComponent): ChessTile[] {
    if (tile.piece?.type === "King") {
      return this.findKingMoves(tile, board);
    }
    else if (tile.piece?.type === "Knight") {
      return this.findKnightMoves(tile, board);
    }
    else if (tile.piece?.type === "Bishop") {
      return this.findBishopMoves(tile, board);
    }
    else if (tile.piece?.type === "Rook") {
      return this.findRookMoves(tile, board);
    }
    else {
      return [];
    }
  }

  findRookMoves(tile: ChessTile, board: ChessboardComponent): ChessTile[] {
    let moves: ChessTile[] = [];
    let moveLength = 1;
    let squareStatus = "open";
    while (this.legalSquare(tile.x+moveLength, tile.y) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x+moveLength, tile.y));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x+moveLength, tile.y));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x, tile.y+moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x, tile.y+moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x, tile.y+moveLength));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x-moveLength, tile.y) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x-moveLength, tile.y));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x-moveLength, tile.y));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x, tile.y-moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x, tile.y-moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x, tile.y-moveLength));
      }
      moveLength++;
    }
    return moves;
  }

  findBishopMoves(tile: ChessTile, board: ChessboardComponent): ChessTile[] {
    let moves: ChessTile[] = [];
    let moveLength = 1;
    let squareStatus = "open";
    while (this.legalSquare(tile.x+moveLength, tile.y+moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x+moveLength, tile.y+moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x+moveLength, tile.y+moveLength));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x-moveLength, tile.y+moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x-moveLength, tile.y+moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x-moveLength, tile.y+moveLength));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x+moveLength, tile.y-moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x+moveLength, tile.y-moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x+moveLength, tile.y-moveLength));
      }
      moveLength++;
    }
    moveLength = 1;
    squareStatus = "open";
    while (this.legalSquare(tile.x-moveLength, tile.y-moveLength) && squareStatus === "open") {
      squareStatus = this.squareOpen(tile, board.getTile(tile.x-moveLength, tile.y-moveLength));
      if (squareStatus !== "same") {
        moves.push(board.getTile(tile.x-moveLength, tile.y-moveLength));
      }
      moveLength++;
    }
    return moves;
  }

  findKnightMoves(tile: ChessTile, board: ChessboardComponent): ChessTile[] {
    let moves: ChessTile[] = [];
    let horizontalMovement = 1;
    for (horizontalMovement; horizontalMovement<3; horizontalMovement++) {
      let verticalMovement = 3-horizontalMovement;
      if (this.legalSquare(tile.x-horizontalMovement, tile.y-verticalMovement)
        && this.squareOpen(tile, board.getTile(tile.x-horizontalMovement, tile.y-verticalMovement)) !== "same") {
          moves.push(board.getTile(tile.x-horizontalMovement, tile.y-verticalMovement));
      }
      if (this.legalSquare(tile.x+horizontalMovement, tile.y-verticalMovement)
        && this.squareOpen(tile, board.getTile(tile.x+horizontalMovement, tile.y-verticalMovement)) !== "same") {
          moves.push(board.getTile(tile.x+horizontalMovement, tile.y-verticalMovement));
      }
      if (this.legalSquare(tile.x-horizontalMovement, tile.y+verticalMovement)
        && this.squareOpen(tile, board.getTile(tile.x-horizontalMovement, tile.y+verticalMovement)) !== "same") {
          moves.push(board.getTile(tile.x-horizontalMovement, tile.y+verticalMovement));
      }
      if (this.legalSquare(tile.x+horizontalMovement, tile.y+verticalMovement)
        && this.squareOpen(tile, board.getTile(tile.x+horizontalMovement, tile.y+verticalMovement)) !== "same") {
          moves.push(board.getTile(tile.x+horizontalMovement, tile.y+verticalMovement));
      }
    }
    return moves;
  }

  findKingMoves(tile: ChessTile, board: ChessboardComponent): ChessTile[] {
    let moves: ChessTile[] = [];
    let x=tile.x-1;
    for (x; x<tile.x+2; x++) {
      let y=tile.y-1;
      for (y; y<tile.y+2; y++) {
        if ( (tile.x != x || tile.y != y) && this.legalSquare(x,y)
          && (this.squareOpen(tile, board.getTile(x,y)) !== "same")) {
            moves.push(board.getTile(x,y));
        }
      }
    }
    return moves;
  }

  legalSquare(x:number, y:number): boolean {
    return ( (x>-1 && x<8) && (y>-1 && y<8) );
  }

  squareOpen(startingTile: ChessTile, targetTile: ChessTile): string {
    if (!targetTile.piece) {
      return "open";
    }
    else if (targetTile.piece?.color === startingTile.piece?.color) {
      return "same";
    }
    else {
      return "different";
    }
  }

  constructor() { }
}
