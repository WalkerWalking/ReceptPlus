import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Recepiesfrominventory } from './recepiesfrominventory';

describe('Recepiesfrominventory', () => {
  let component: Recepiesfrominventory;
  let fixture: ComponentFixture<Recepiesfrominventory>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Recepiesfrominventory]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Recepiesfrominventory);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
