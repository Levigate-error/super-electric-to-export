import React from "react";
import ReactDOM from "react-dom";
import ProjectsList from "./ProjectsList";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<ProjectsList store={data} />, document.getElementById("app"));
