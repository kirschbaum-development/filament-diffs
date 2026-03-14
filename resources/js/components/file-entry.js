import { File } from '@pierre/diffs'

export default function fileEntry({ content, fileName, language, options }) {
    return {
        instance: null,

        init() {
            this.render()
        },

        render() {
            this.cleanup()

            const file = {
                name: fileName || 'file',
                contents: content || '',
                ...(language ? { lang: language } : {}),
            }

            this.instance = new File(options || {})

            this.instance.render({
                file,
                containerWrapper: this.$refs.mount,
            })
        },

        cleanup() {
            if (this.instance) {
                this.instance.cleanUp()
                this.instance = null
            }
        },

        destroy() {
            this.cleanup()
        },
    }
}
