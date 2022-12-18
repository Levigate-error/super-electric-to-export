import React from "react";
import ReactDOM from "react-dom";
import ProjectForm from "./ProjectForm";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<ProjectForm store={data} />, document.getElementById("app"));
