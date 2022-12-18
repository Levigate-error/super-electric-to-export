import { actionTypes } from "./reducer";

export const setErrorHelper = (dispatch, errors) => {
    if (errors.email)
        dispatch({
            type: actionTypes.SET_EMAIL_ERROR,
            payload: errors.email[0]
        });
};
