import * as React from "react";
import classnames from "classnames";
import { IFavorites } from "./types";
import { favoriteIcon } from "../Icons/Icons";

function FavoritesButton(props: IFavorites) {
    const { isActive, action, disabled } = props;
    return (
        <button
            title="Избранное"
            disabled={disabled}
            className={classnames("favorites-marker", {
                "favorite-active": isActive
            })}
            onClick={action}
        >
            {favoriteIcon}
        </button>
    );
}

export default React.memo(FavoritesButton);
