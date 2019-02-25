import React from 'react'
import { render } from 'react-dom'
import { RepLogApp } from './RepLog/RepLogApp'
import RepLogs from "./RepLog/RepLogs";
import PropTypes from "prop-types";

render(
    <RepLogApp
        withHart={true}
    />,
    document.getElementById('lift-stuff-app')
);

RepLogs.propTypes = {
    withHeart: PropTypes.bool,
};