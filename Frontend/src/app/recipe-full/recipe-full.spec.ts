import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecipeFull } from './recipe-full';

describe('RecipeFull', () => {
  let component: RecipeFull;
  let fixture: ComponentFixture<RecipeFull>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RecipeFull]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecipeFull);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
