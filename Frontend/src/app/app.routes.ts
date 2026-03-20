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

export const routes: Routes = [
  { path: '', component: AllRecipes },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'recipesFromInventory', component: Recepiesfrominventory },
  { path: 'user-recipes', component: Userrecepies },
  { path: 'user-storage', component: Userstorage },
  { path: 'account', component: Accountinfo },
  { path: 'allRecipes', component: AllRecipes },
  { path: 'recipe-full', component: RecipeFull },
  { path: 'recipe-add', component: AddRecipe },
  
  { path: 'reset-password', component: Resetpasswordcomponent },

  { path: '**', redirectTo: '' }
];