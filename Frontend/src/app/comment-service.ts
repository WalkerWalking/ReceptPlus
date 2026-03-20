import { Injectable, signal, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, catchError, of, tap, throwError } from 'rxjs';
import { Comment } from './models/comment.model';
import { ToastService } from './toastwindowservice';

@Injectable({
  providedIn: 'root'
})
export class CommentService {
  private http = inject(HttpClient);
  private toast = inject(ToastService);

  getCommentsByRecipeId(recipeId: number): Observable<Comment[]> {
    return this.http.get<Comment[]>(`http://127.0.0.1:8000/api/comments/getByRecipeId/${recipeId}`).pipe(
      catchError((error) => {
        if (error.status === 404) {
          return of([]);
        }
        this.toast.show('Nem sikerült betölteni a hozzászólásokat.', 'error');
        return throwError(() => error);
      })
    );
  }

  createComment(comment: { content: string; recipeId: number; userId: number }): Observable<any> {
    return this.http.post<any>('http://127.0.0.1:8000/api/comments', comment).pipe(
      tap(() => {
        this.toast.show('Hozzászólás elküldve!', 'success');
      }),
      catchError((err) => {
        this.toast.show('Hiba történt a küldés során.', 'error');
        return throwError(() => err);
      })
    );
  }

  deleteComment(commentId: number): Observable<any> {
    return this.http.delete<any>(`http://127.0.0.1:8000/api/comments/${commentId}`).pipe(
      tap(() => {
        this.toast.show('Hozzászólás törölve.', 'info');
      }),
      catchError((err) => {
        this.toast.show('Nem sikerült törölni a kommentet.', 'error');
        return throwError(() => err);
      })
    );
  }
}