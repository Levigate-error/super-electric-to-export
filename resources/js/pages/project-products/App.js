import React from "react";
import ReactDOM from "react-dom";
import ProjectProducts from "./ProjectProducts";

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(
    <ProjectProducts store={data} />,
    document.getElementById("app")
);
