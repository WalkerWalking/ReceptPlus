/* export interface Ingredient {
  name: string;
  amount: string;
}

export interface Recipe {
  id: number;
  name: string;
  imageUrl: string;
  rating: number;
  commentsCount: number;
  ingredients: Ingredient[];
} */


export interface Recipe {
  id: number;
  name: string;
  userId: number;
  imageUrl: string;
  isMakeable: boolean;
  description: string;
  calories: number;
  ingredients: RecipeIngredient[];
}

export interface RecipeIngredient{
  id: number;
  name: string;
  amount: number;
  unit: string;
}