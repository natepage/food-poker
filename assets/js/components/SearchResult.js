import React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@material-ui/core/CircularProgress';
import compose from 'recompose/compose';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { selectSearchAddress } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

class SearchResult extends React.Component
{
    render() {
        return (
            <div className={this.props.classes.root}>
                {this.props.isSearching &&
                    <div className={this.props.classes.loaderContainer}>
                        <CircularProgress/>
                    </div>
                }
            </div>
        )
    }
}

const mapStateToProps = (store) => {
    return {
        isSearching: store.state.isSearching
    }
};

const styles = theme => ({
    loaderContainer: {
        display: 'flex',
        justifyContent: 'center'
    },
    root: {
        marginTop: 24
    }
});

SearchResult.propTypes = {
    classes: PropTypes.object.isRequired,
    isSearching: PropTypes.bool.isRequired
};

export default compose(withStyles(styles), connect(mapStateToProps))(SearchResult);
