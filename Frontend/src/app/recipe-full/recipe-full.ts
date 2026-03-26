import { Component, OnInit, signal, inject, Signal, computed } from '@angular/core';
import { RecipeService } from '../recipe.service';
import { Recipe } from '../models/recipe.model';
import { Router } from '@angular/router';
import { AuthService } from '../auth-service';
import { UserStorageService } from '../user-storage-service';
import { CommentService } from '../comment-service';
import { Comment } from '../models/comment.model';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ToastService } from '../toastwindowservice';

@Component({
  selector: 'app-recipe-full',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './recipe-full.html',
  styleUrl: './recipe-full.scss',
})
export class RecipeFull implements OnInit {
  public recipeService = inject(RecipeService);
  private userStorageService = inject(UserStorageService);
  private router = inject(Router);
  public auth = inject(AuthService);
  private commentService = inject(CommentService);
  private toast = inject(ToastService);

  selectedRecipe!: Signal<Recipe | null>;
  comments = signal<any[]>([]);
  newCommentContent = '';
  errorMessage = signal<string | null>(null);

  private epicNames = ['Kóbor Gulyáslovag', 'Füstös Paprikamester', 'Nemes Nokedli-aprító', 'Titkos Receptőrző', 'Éhes Sárkányölő', 'Páncélos Palacsintahős', 'Kardos Köménymag', 'Bátor Borjúpörkölthajhász', 'Legendás Lángosfaló'];
  private noteColors = ['#fefae0', '#e9edc9', '#faedcd', '#f0ead2', '#d4a37344'];

  ngOnInit() {
    this.selectedRecipe = this.recipeService.selectedRecipe;

    if (this.selectedRecipe()) {
      this.loadComments();
    } else {
      this.router.navigate(['/all-recipes']);
    }
  }

  backToHome() {
    this.router.navigate(['/all-recipes']);
  }

  async makeSelectedRecipe() {
    const recipe = this.selectedRecipe();
    if (!recipe) return;

    const confirmed = await this.toast.askConfirmation(
      'Recept elkészítése',
      `Biztosan elkészíted a következőt: ${recipe.name}? Amennyiben rendelkezel a szükséges alapanyagokkal, azok levonásra kerülnek a raktáradból.`
    );

    if (!confirmed) return;

    this.recipeService.makeRecipe(recipe.id).subscribe({
      next: (response) => {
        this.auth.loggedInUser.set(response.user);
        localStorage.setItem('loggedInUser', JSON.stringify(response.user));
        this.userStorageService.setUserIngredients(response.remainingIngredients);

        this.toast.show("Jó étvágyat! A receptet sikeresen elkészítve! :3", "success");
      },
      error: (err) => {
        console.error(err);
        this.toast.show(err.error?.message ?? 'Hiba történt az elkészítés során.', 'error');
      }
    });
  }

  loadComments(): void {
    const recipe = this.selectedRecipe();
    if (!recipe) return;

    this.commentService.getCommentsByRecipeId(recipe.id).subscribe({
      next: (data: Comment[]) => {
        const mapped = data.map(c => ({
          ...c,
          epicName: this.epicNames[Math.floor(Math.random() * this.epicNames.length)],
          rotation: Math.floor(Math.random() * 8) - 4,
          color: this.noteColors[Math.floor(Math.random() * this.noteColors.length)]
        }));
        this.comments.set(mapped);
        this.errorMessage.set(null);
      },
      error: () => {
        this.toast.show('Hiba történt a kommentek betöltése során.', 'error');
      }
    });
  }

  addComment(): void {
    const user = this.auth.loggedInUser();
    const recipe = this.selectedRecipe();

    if (!user || !recipe) return;
    if (!this.newCommentContent.trim()) {
      this.toast.show('A komment nem lehet üres.', 'info');
      return;
    }

    this.commentService.createComment({
      content: this.newCommentContent,
      recipeId: recipe.id,
      userId: user.id
    }).subscribe({
      next: () => {
        this.newCommentContent = '';
        this.loadComments();
        this.toast.show('Hozzászólás hozzáadva!', 'success');
      },
      error: (err) => {
        const msg = err.status === 401 ? err.error['Hiba!'] : 'Hiba történt a mentés során.';
        this.toast.show(msg, 'error');
      }
    });
  }

  async deleteComment(commentId: number) {
    const confirmed = await this.toast.askConfirmation(
      'Komment törlése',
      'Biztosan törölni szeretnéd ezt a hozzászólást?'
    );

    if (!confirmed) return;

    this.commentService.deleteComment(commentId).subscribe({
      next: (response) => {
        this.toast.show(response['Siker!'] || 'Törölve.', 'info');
        this.loadComments();
      },
      error: (err) => {
        const msg = err.status === 404 ? err.error['Hiba!'] : 'Hiba történt a törlés során.';
        this.toast.show(msg, 'error');
      }
    });
  }

  isOwnComment(comment: any): boolean {
    const currentUser = this.auth.loggedInUser();
    return currentUser ? currentUser.id === comment.userId : false;
  }
}