import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WinesComponent } from './wines.component';

describe('WinesComponent', () => {
  let component: WinesComponent;
  let fixture: ComponentFixture<WinesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WinesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(WinesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
