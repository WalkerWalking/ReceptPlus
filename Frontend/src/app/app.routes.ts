import { Routes } from '@angular/router';
import { Login } from './login/login';
import { Recepiesfrominventory } from './recepiesfrominventory/recepiesfrominventory';
import { Accountinfo } from './accountinfo/accountinfo';
import { Userrecepies } from './userrecepies/userrecepies';
import { Register } from './register/register';
import { Userstorage } from './userstorage/userstorage';
import { AllRecipes } from './all-recipes/all-recipes';
import { RecipeFull } from './recipe-full/recipe-full';
import { AddRecipe } from './add-recipe/add-recipe';
import { Resetpasswordcomponent } from './resetpasswordcomponent/resetpasswordcomponent'; 
import { Aboutuscomponent } from './aboutuscomponent/aboutuscomponent';
import { AuthguardService } from './authguard-service';

export const routes: Routes = [
  { path: '', component: AllRecipes },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'recipesFromInventory', component: Recepiesfrominventory, canActivate: [AuthguardService] },
  { path: 'user-recipes', component: Userrecepies, canActivate: [AuthguardService] },
  { path: 'user-storage', component: Userstorage, canActivate: [AuthguardService] },
  { path: 'account', component: Accountinfo, canActivate: [AuthguardService] },
  { path: 'allRecipes', component: AllRecipes },
  { path: 'recipe-full', component: RecipeFull },
  { path: 'recipe-add', component: AddRecipe, canActivate: [AuthguardService] },
  { path: 'about-us', component: Aboutuscomponent },

  { path: 'reset-password', component: Resetpasswordcomponent },

  { path: '**', redirectTo: '' }
];