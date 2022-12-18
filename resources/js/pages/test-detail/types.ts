export type TTest = {
    id: number;
    title: string;
    description: string;
    image: string;
    created_at: string;
    questions: TQuestion[];
};

export type TQuestion = {
    id: number;
    question: string;
    image: string;
    created_at: string;
    answers: TAnswers[];
};

// TODO: add TAnswers
export type TAnswers = {
    id: number;
    answer: string;
    is_correct: boolean;
    description: string;
    points: number;
    created_at: string;
};
