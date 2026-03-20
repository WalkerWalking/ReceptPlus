import { Injectable, signal } from '@angular/core';

export type ToastType = 'success' | 'error' | 'info';

@Injectable({ providedIn: 'root' })
export class ToastService {
  isVisible = signal(false);
  message = signal('');
  type = signal<ToastType>('info');

  show(msg: string, type: ToastType = 'info') {
    this.message.set(msg);
    this.type.set(type);
    this.isVisible.set(true);

    setTimeout(() => this.hide(), 3000);
  }

  hide() {
    this.isVisible.set(false);
  }

  confirmTitle = signal('');
  confirmMessage = signal('');
  isConfirmVisible = signal(false);
  private confirmResolver: (value: boolean) => void = () => { };

  askConfirmation(title: string, message: string): Promise<boolean> {
    this.confirmTitle.set(title);
    this.confirmMessage.set(message);
    this.isConfirmVisible.set(true);

    return new Promise((resolve) => {
      this.confirmResolver = resolve;
    });
  }

  resolveConfirm(result: boolean) {
    this.isConfirmVisible.set(false);
    this.confirmResolver(result);
  }
}