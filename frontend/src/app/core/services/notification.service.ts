import { Injectable, inject } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn:'root'
})
export class NotificationService {

  snack=inject(MatSnackBar);

  success(message:string){

    this.snack.open(message,'Aceptar',{

      duration:3000,
      panelClass:['success-snackbar']

    });

  }

  error(message:string){

    this.snack.open(message,'Cerrar',{

      duration:4000,
      panelClass:['error-snackbar']

    });

  }

}
