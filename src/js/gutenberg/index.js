import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";

registerPlugin('hide-post-sidebar', {
    icon: 'smiley',
    render: () => {
        return (
            <PluginSidebar title={'Hide Post'}>
                Some Content
            </PluginSidebar>
        );
    }
});