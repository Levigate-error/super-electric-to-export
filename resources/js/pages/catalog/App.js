import React from "react";
import ReactDOM from "react-dom";
import Catalog from "./Catalog";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Catalog store={data} />, document.getElementById("app"));
