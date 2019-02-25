import React, { Component } from "react";
import RepLogs from "./RepLogs";
import PropTypes from "prop-types"
import uuid from 'uuid/v4';

export class RepLogApp extends Component {
    constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            repLogs: [
                { id: uuid(), reps: 25, itemLabel: 'My Laptop', totalWeightLifted: 112.5 },
                { id: uuid(), reps: 10, itemLabel: 'Big Fat Cat', totalWeightLifted: 180 },
                { id: uuid(), reps: 4, itemLabel: 'Big Fat Cat', totalWeightLifted: 72 }
            ]
        };

        this.handleRowClick = this.handleRowClick.bind(this);
        this.handleNewItemSubmit = this.handleNewItemSubmit.bind(this);
    }

    handleRowClick(repLogId) {
        this.setState({highlightedRowId: repLogId})
    }

    handleNewItemSubmit(itemLabel, quantity) {
        let { repLogs } = this.state;

        repLogs.push(
            {
                id: uuid(),
                reps: quantity,
                itemLabel: itemLabel,
                totalWeightLifted: Math.floor(Math.random()*50)
            }
        );

        this.setState({repLogs: repLogs});

    }

    render() {

        return <RepLogs
            {...this.state}
            {...this.props}
            handleRowClick={this.handleRowClick}
            onNewItemSubmit={this.handleNewItemSubmit}
        />
    }
}

RepLogs.propTypes = {
    highlightedRowId: PropTypes.number,
    handleRowClick: PropTypes.func.isRequired,
    onNewItemSubmit: PropTypes.func.isRequired,
    withHeart: PropTypes.bool,
    repLogs: PropTypes.array.isRequired
};
