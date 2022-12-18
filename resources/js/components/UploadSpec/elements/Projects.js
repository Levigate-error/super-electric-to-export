"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Changes_1 = require("./Changes");
const SelectProjects_1 = require("./SelectProjects");
const Projects = ({ projects, selectedProjects, changeCheckbox, createFromFile, compareProjects, projectsChanges, isFetch, }) => {
    return (React.createElement("div", { className: "upload-spec-select-project" }, projectsChanges.length ? (React.createElement(Changes_1.default, { projectsChanges: projectsChanges })) : (React.createElement(SelectProjects_1.default, { projects: projects, selectedProjects: selectedProjects, changeCheckbox: changeCheckbox, createFromFile: createFromFile, compareProjects: compareProjects, isLoading: isFetch }))));
};
exports.default = Projects;
