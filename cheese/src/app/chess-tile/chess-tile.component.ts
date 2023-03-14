import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-chess-tile',
  templateUrl: './chess-tile.component.html',
  styleUrls: ['./chess-tile.component.css']
})
export class ChessTileComponent implements OnInit {

  x = 1;
  y = 1;
  selected = false;
  backgroundColor = "blue";

  selectTile(): void {
    this.selected = !this.selected;
    if (this.selected) {
      this.backgroundColor = "yellow";
    }
    else {this.backgroundColor = "blue"}
  }

  constructor() { }

  ngOnInit(): void {
  }

}
