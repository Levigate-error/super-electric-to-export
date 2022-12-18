import axios from 'axios';

interface IFeedback {
    name: string;
    email: string;
    text: string;
    type: string;
    captcha: string;
}

export const sendFeedback = async ({ name, email, text, type, captcha }: IFeedback, file?: any) => {
    const formData = new FormData();
    file && formData.append('file', file);
    formData.append('name', name);
    formData.append('email', email);
    formData.append('text', text);
    formData.append('type', type);
    formData.append('g-recaptcha-response', captcha);

    const response = await axios.post('/api/feedback', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });

    return response;
};
