import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Toastwindowcomponent } from './toastwindowcomponent';

describe('Toastwindowcomponent', () => {
  let component: Toastwindowcomponent;
  let fixture: ComponentFixture<Toastwindowcomponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Toastwindowcomponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Toastwindowcomponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
