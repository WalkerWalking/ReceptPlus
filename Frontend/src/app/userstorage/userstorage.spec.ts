import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Userstorage } from './userstorage';

describe('Userstorage', () => {
  let component: Userstorage;
  let fixture: ComponentFixture<Userstorage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Userstorage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Userstorage);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
