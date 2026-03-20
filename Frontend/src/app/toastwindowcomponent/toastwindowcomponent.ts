import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ToastService } from '../toastwindowservice';
@Component({
  selector: 'app-toastwindowcomponent',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './toastwindowcomponent.html',
  styleUrl: './toastwindowcomponent.scss',
})
export class Toastwindowcomponent {
  public toastService = inject(ToastService);
}