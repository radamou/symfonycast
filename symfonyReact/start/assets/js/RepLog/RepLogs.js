import React from "react";
import RepLogList from "./RepLogList";
import PropTypes from "prop-types"
import RepLogCreator from "./RefLogCreator";

const calculateTotalWeight = repLogs => repLogs.reduce((total, log) =>  total + log.totalWeightLifted, 0);

export default function RepLogs(props) {
    const { highlightedRowId,repLogs, withHeart, handleRowClick, onNewItemSubmit } = props;
    let heart = withHeart === true ? <span>:D</span> : '';

    return (
        <div className="col-md-7">
            <h2>
                Lift History {heart}
            </h2>

            <table className="table table-striped">
                <thead>
                <tr>
                    <th>What</th>
                    <th>How many times?</th>
                    <th>Weight</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <RepLogList
                    highlightedRowId={highlightedRowId}
                    handleRowClick={handleRowClick}
                    repLogs={repLogs}
                />
                <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <th>Total</th>
                    <th>{calculateTotalWeight(repLogs)}</th>
                    <td>&nbsp;</td>
                </tr>
                </tfoot>
            </table>
            <RepLogCreator onNewItemSubmit={onNewItemSubmit}/>
        </div>
    );
}

RepLogs.propTypes = {
    highlightedRowId: PropTypes.number,
    handleRowClick: PropTypes.func.isRequired,
    onNewItemSubmit: PropTypes.func.isRequired,
    withHeart: PropTypes.bool,
    repLogs: PropTypes.array.isRequired
};