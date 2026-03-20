import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Userrecepies } from './userrecepies';

describe('Userrecepies', () => {
  let component: Userrecepies;
  let fixture: ComponentFixture<Userrecepies>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Userrecepies]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Userrecepies);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
