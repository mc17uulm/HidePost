const { registerPlugin } = wp.plugins;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { __ } = wp.i18n;

registerPlugin('hide-post-sidebar', {
    icon: 'smiley',
    render: () => {
        return (
            <>
                <PluginSidebarMoreMenuItem target="hide-post-sidebar">
                    HidePost
                </PluginSidebarMoreMenuItem>
                <PluginSidebar name="hide-post-sidebar" title={'Hide Post'}>
                    Some Content
                </PluginSidebar>
            </>
        );
    }
});