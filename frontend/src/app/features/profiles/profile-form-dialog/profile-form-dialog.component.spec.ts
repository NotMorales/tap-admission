import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfileFormDialogComponent } from './profile-form-dialog.component';

describe('ProfileFormDialogComponent', () => {
  let component: ProfileFormDialogComponent;
  let fixture: ComponentFixture<ProfileFormDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProfileFormDialogComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfileFormDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
