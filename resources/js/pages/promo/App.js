import React from "react";
import ReactDOM from "react-dom";
import Promo from "./Promo";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Promo store={data} />, document.getElementById('app'));
