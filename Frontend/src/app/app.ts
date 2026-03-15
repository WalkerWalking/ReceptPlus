import { Component, signal } from '@angular/core';
import { RouterOutlet, Router } from '@angular/router'; // Behozzuk a Router-t
import { Navbar } from './navbar/navbar';
import { Searchbar } from './searchbar/searchbar';
import { Recepiesfrominventory } from './recepiesfrominventory/recepiesfrominventory';
import { Footer } from "./footer/footer";

@Component({
  selector: 'app-root',
  standalone: true, // Feltételezve, hogy standalone
  imports: [RouterOutlet, Navbar, Searchbar, Footer],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  protected readonly title = signal('receptPlus');
  constructor(public router: Router) {}
}