
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

