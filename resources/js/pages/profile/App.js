import React from "react";
import ReactDOM from "react-dom";
import Profile from "./Profile";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Profile store={data} />, document.getElementById("app"));
