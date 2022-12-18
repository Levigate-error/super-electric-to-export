import React from "react";
import ProjectSpec from "./ProjectSpec";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<ProjectSpec store={data} />);
dispatch(html);
