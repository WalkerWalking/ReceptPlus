import { Component, signal, HostListener, ElementRef, ViewChild } from '@angular/core';
import { RouterOutlet, Router } from '@angular/router';
import { Navbar } from './navbar/navbar';
import { Searchbar } from './searchbar/searchbar';
import { Footer } from "./footer/footer";
import { Toastwindowcomponent } from './toastwindowcomponent/toastwindowcomponent';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, Navbar, Searchbar, Footer, Toastwindowcomponent],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  protected readonly title = signal('receptPlus');
  showScrollButton = false;
  scrollBottom = 56;

  @ViewChild('footerRef', { static: false }) footer!: ElementRef;

  constructor(public router: Router) {}

  @HostListener('window:scroll', [])
  onWindowScroll(): void {
    this.showScrollButton = window.scrollY > 150;

    if (this.footer) {
      const footerRect = this.footer.nativeElement.getBoundingClientRect();
      const overlap = window.innerHeight - footerRect.top;

      if (overlap > 0) {
        this.scrollBottom = 56 + overlap;
      } else {
        this.scrollBottom = 56;
      }
    }
  }

  scrollToTop(): void {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}