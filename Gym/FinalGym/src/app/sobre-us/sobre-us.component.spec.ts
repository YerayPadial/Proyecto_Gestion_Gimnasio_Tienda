import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SobreUsComponent } from './sobre-us.component';

describe('SobreUsComponent', () => {
  let component: SobreUsComponent;
  let fixture: ComponentFixture<SobreUsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SobreUsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SobreUsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
