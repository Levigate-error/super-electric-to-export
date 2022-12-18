import React from "react";
import ReactDOM from "react-dom";
import Product from "./Product";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Product store={data} />, document.getElementById("app"));
