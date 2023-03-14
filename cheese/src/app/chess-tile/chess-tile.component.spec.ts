import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChessTileComponent } from './chess-tile.component';

describe('ChessTileComponent', () => {
  let component: ChessTileComponent;
  let fixture: ComponentFixture<ChessTileComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ChessTileComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ChessTileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
