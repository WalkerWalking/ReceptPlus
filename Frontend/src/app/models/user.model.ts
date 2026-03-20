export interface User {
    id: number;
    passwrd: string;
    email: string;
    name: string;
    username: string;
    bodyweightKg: number;
    heightCm: number;
    birthDate: string;
    profilePictureUrl: string;
    caloriesEaten: number;

    bmi?: number;
    calorieGoal?: number;
}