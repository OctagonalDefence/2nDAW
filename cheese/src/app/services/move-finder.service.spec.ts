import { TestBed } from '@angular/core/testing';

import { MoveFinderService } from './move-finder.service';

describe('MoveFinderService', () => {
  let service: MoveFinderService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MoveFinderService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
