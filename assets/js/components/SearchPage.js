import React from 'react';
import PropTypes from 'prop-types';
import Button from '@material-ui/core/Button';
import ResponsiveContainer from './ResponsiveContainer';
import SearchInput from './SearchInput';
import SearchResult from './SearchResult';
import compose from 'recompose/compose';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { searchRestaurant } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

const styles = {
    buttonContainer: {
        display: 'flex',
        justifyContent: 'center'
    },
    root: {
        marginTop: 24
    }
};

class SearchPage extends React.Component
{
    constructor(props) {
        super(props);

        this.handleSearchButton = this.handleSearchButton.bind(this);
    }

    handleSearchButton() {
        this.props.searchRestaurant({address: this.props.searchAddress});
    }

    render() {
        return (
            <div className={this.props.classes.root}>
                <ResponsiveContainer>
                    <SearchInput/>
                    <div className={this.props.classes.buttonContainer}>
                        <Button variant={"contained"} color={"primary"} onClick={this.handleSearchButton}>
                            Search
                        </Button>
                    </div>
                    <SearchResult/>
                </ResponsiveContainer>
            </div>
        );
    }
}

const mapStateToProps = (store) => {
    return {
        searchAddress: store.state.searchAddress
    }
};

const mapDispatchToProps = (dispatch) => {
    return bindActionCreators({ searchRestaurant }, dispatch);
};

SearchPage.propTypes = {
    classes: PropTypes.object.isRequired,
    searchAddress: PropTypes.string.isRequired,
    searchRestaurant: PropTypes.func.isRequired
};

export default compose(withStyles(styles), connect(mapStateToProps, mapDispatchToProps))(SearchPage);