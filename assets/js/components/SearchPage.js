import React from 'react';
import PropTypes from 'prop-types';
import ResponsiveContainer from './ResponsiveContainer';
import SearchInput from './SearchInput';
import { withStyles } from '@material-ui/core/styles';

const styles = {
    root: {
        marginTop: 24
    }
};

class SearchPage extends React.Component {
    render() {
        return (
            <div className={this.props.classes.root}>
                <ResponsiveContainer>
                    <SearchInput/>
                </ResponsiveContainer>
            </div>
        );
    }
}

SearchInput.propTypes = {
    classes: PropTypes.object.isRequired
};

export default withStyles(styles)(SearchPage);