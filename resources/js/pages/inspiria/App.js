import React from "react";
import ReactDOM from "react-dom";
import Loyalty from "./Loyalty";
//import Loyality from "./Loyality";


const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Loyalty store={data} />, document.getElementById("app"));
