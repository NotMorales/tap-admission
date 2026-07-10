import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProfileDetailDialogComponent } from './profile-detail-dialog.component';

describe('ProfileDetailDialogComponent', () => {
  let component: ProfileDetailDialogComponent;
  let fixture: ComponentFixture<ProfileDetailDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProfileDetailDialogComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProfileDetailDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
