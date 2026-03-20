import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Resetpasswordcomponent } from './resetpasswordcomponent';

describe('Resetpasswordcomponent', () => {
  let component: Resetpasswordcomponent;
  let fixture: ComponentFixture<Resetpasswordcomponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Resetpasswordcomponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Resetpasswordcomponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
