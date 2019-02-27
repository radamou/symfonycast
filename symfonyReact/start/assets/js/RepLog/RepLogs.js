import React from "react";
import RepLogList from "./RepLogList";
import PropTypes from "prop-types"
import RepLogCreator from "./RefLogCreator";

const calculateTotalWeight = repLogs => repLogs.reduce((total, log) =>  total + log.totalWeightLifted, 0);

export default function RepLogs(props) {
    const {
        highlightedRowId,
        repLogs,
        handleRowClick,
        handleAddRepLog,
        handleDeleteRepLog,
        numberOfHearts,
        OnHeartChange,
        isLoaded,
        isSavingNewRepLog
    } = props;

    const heart = <span>{'❤️'.repeat(numberOfHearts)}</span>;

    return (
        <div className="col-md-7">
            <h2>
                Lift History {heart}
            </h2>

            <input type="range" value={numberOfHearts} onChange={(e) => {
                OnHeartChange(+e.target.value)
            }}/>

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
                    handleDeleteRepLog={handleDeleteRepLog}
                    repLogs={repLogs}
                    isLoaded={isLoaded}
                    isSavingNewRepLog={isSavingNewRepLog}
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
            <div className="row">
                <div className="col-md-6">
                    <RepLogCreator
                        handleAddRepLog={handleAddRepLog}
                    />
                </div>
            </div>
        </div>
    );
}

RepLogs.propTypes = {
    highlightedRowId: PropTypes.any,
    handleRowClick: PropTypes.func.isRequired,
    handleAddRepLog: PropTypes.func.isRequired,
    handleDeleteRepLog:PropTypes.func.isRequired,
    OnHeartChange: PropTypes.func.isRequired,
    withHeart: PropTypes.bool,
    repLogs: PropTypes.array.isRequired,
    numberOfHearts: PropTypes.number.isRequired,
    isLoaded: PropTypes.bool.isRequired,
    isSavingNewRepLog: PropTypes.bool.isRequired
};