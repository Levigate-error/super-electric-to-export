import React from "react";
import ProjectForm from "./ProjectForm";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<ProjectForm store={data} />);
dispatch(html);
