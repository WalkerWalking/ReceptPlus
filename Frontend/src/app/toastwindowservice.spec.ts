import { TestBed } from '@angular/core/testing';

import { Toastwindowservice } from './toastwindowservice';

describe('Toastwindowservice', () => {
  let service: Toastwindowservice;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Toastwindowservice);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
