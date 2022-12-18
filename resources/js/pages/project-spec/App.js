import React from "react";
import ReactDOM from "react-dom";
import ProjectSpec from "./ProjectSpec";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<ProjectSpec store={data} />, document.getElementById("app"));
