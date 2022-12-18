import { actionTypes } from "./reducer";

export const setErrorHelper = (dispatch, errors) => {
    if (errors.email)
        dispatch({
            type: actionTypes.SET_EMAIL_ERROR,
            payload: errors.email[0]
        });
    if (errors.password)
        dispatch({
            type: actionTypes.SET_PASSWORD_ERROR,
            payload: errors.password[0]
        });
};
